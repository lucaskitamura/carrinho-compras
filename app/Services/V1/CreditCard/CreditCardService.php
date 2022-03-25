<?php

namespace App\Services\V1\CreditCard;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Exceptions\ValidateCardException;
use App\Services\V1\Contracts\CreditCardServiceContract;
use App\Repositories\Contracts\CreditCardRepositoryContract;

class CreditCardService implements CreditCardServiceContract
{
    const AVALIABLE_BRANDS = [
        'VISA',
        'MASTERCARD',
        'DINERS'
    ];

    private $creditCardRepositoryContract;

    public function __construct(CreditCardRepositoryContract $creditCardRepositoryContract)
    {
        $this->creditCardRepositoryContract = $creditCardRepositoryContract;
    }

    /**
     * @param array $creditCardStoreRequest
     * @return bool
     */
    private function validateCreditCard(array $creditCardStoreRequest):bool
    {
        if (!self::validateBrand($creditCardStoreRequest['brand'])) {
            throw new ValidateCardException('Invalid credit card: Invalid brand');
        }

        if (!self::validateNumberOfDigits($creditCardStoreRequest['brand'], $creditCardStoreRequest['card_number'])) {
            throw new ValidateCardException('Invalid credit card: Invalid credit card number digits');
        }

        if (!self::validateSecurityCode($creditCardStoreRequest['security_code'])) {
            throw new ValidateCardException('Invalid credit card: Invalid credit card security code');
        }

        if (self::validateExpirationDate($creditCardStoreRequest['expiration_date'])) {
            throw new ValidateCardException('Invalid credit card: Invalid credit card expiration date');
        }

        return true;
    }

    /**
     * @param string $brand
     * @return bool
     */
    private function validateBrand(string $brand):bool
    {
        return in_array(Str::upper($brand), self::AVALIABLE_BRANDS);
    }

    /**
     * @param string $creditCardbrand
     * @param string $creditCardNumber
     * @return bool
     */
    private function validateNumberOfDigits(string $creditCardbrand, string $creditCardNumber):bool
    {
        switch (Str::upper($creditCardbrand)) {
            case 'VISA':
            case 'MASTERCARD':
                return strlen($creditCardNumber) == 16;
                break;

            case 'DINERS':
                return strlen($creditCardNumber) == 14;
                break;
        }
        return false;
    }

    /**
     * @param int $securityCode
     * @return bool
     */
    private function validateSecurityCode(string $securityCode):bool
    {
        return strlen($securityCode) == 3;
    }

    /**
     * @param string $expirationDate
     * @return bool
     */
    private function validateExpirationDate(string $expirationDate):bool
    {
        return Carbon::createFromFormat('m/Y', $expirationDate)
                        ->firstOfMonth()
                        ->isPast();
    }

    /**
     * @param array $data
     */
    public function store(array $data)
    {
        if (self::validateCreditCard($data)) {
            return $this->creditCardRepositoryContract->store($data);
        }

        return false;
    }

    /**
     * @param int $creditCardId
     * @param array $data
     * @return bool
     */
    public function update(int $creditCardId, array $data)
    {
        if ($this->find($creditCardId) && self::validateCreditCard($data)) {
            return $this->creditCardRepositoryContract->update($creditCardId, $data);
        }
        return false;
    }

    /**
     * @param int $creditCardId
     * @return
     */
    public function find(int $creditCardId)
    {
        return $this->creditCardRepositoryContract->find($creditCardId);
    }

    /**
     * @param int $creditCardId
     * @return bool
     */
    public function delete(int $creditCardId):bool
    {
        if ($this->find($creditCardId)) {
            return $this->creditCardRepositoryContract->delete($creditCardId);
        }
        return false;
    }

    /**
     * @param string $number
     * @param string $maskingCharacter
     * @return bool
     */
    public function creditCardMasking(string $number, string $maskingCharacter = '*'):string
    {
        switch (strlen($number)) {
            case 14:
                return rtrim(chunk_split(str_repeat($maskingCharacter, strlen($number) - 4) . substr($number, -4), 4, ' '));
                break;

            case 16:
                return chunk_split(str_repeat($maskingCharacter, strlen($number) - 4) . substr($number, -4), 4, ' ');
                break;
        }
    }

}
