<?php

namespace Bitrix24Api\Models;

use Bitrix24Api\Exceptions\InvalidArgumentException;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class AppModel extends AbstractModel implements HasIdInterface
{
    protected int $id;
    protected string $code;
    protected ?int $version;
    protected string $status;
    protected bool $installed;
    protected bool $paymentExpired;
    protected int $days;
    protected string $license;
    protected string $licenseType;
    protected string $licenseFamily;

    /**
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $app): self
    {
        if (empty($app['ID'])) {
            throw new InvalidArgumentException('App id is empty in ' . json_encode($app));
        }
        $model = new self($app);
        $model->setId((int)$app['ID'])->setCode($app['CODE'])->setVersion((int)$app['VERSION'])
            ->setStatus($app['STATUS'])
            ->setInstalled((bool)$app['INSTALLED'])
            ->setPaymentExpired($app['PAYMENT_EXPIRED'] == 'Y' ? 'Y' : 'N')
            ->setDays((int)$app['DAYS'])
            ->setLicense($app['LICENSE'])
            ->setLicenseType($app['LICENSE_TYPE'] ?? '')
            ->setLicenseFamily($app['LICENSE_FAMILY'] ?? '');

        return $model;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'CODE' => $this->getCode(),
            'VERSION' => $this->getVersion(),
            'STATUS' => $this->getStatus(),
            'INSTALLED' => $this->isInstalled(),
            'PAYMENT_EXPIRED' => $this->isPaymentExpired(),
            'DAYS' => $this->getDays(),
            'LICENSE' => $this->getLicense(),
            'LICENSE_TYPE' => $this->getLicenseType(),
            'LICENSE_FAMILY' => $this->getLicenseFamily(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @param int|null $version
     * @return $this
     */
    public function setVersion(?int $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * статус приложения. Возможные значения:
     *
     * F (Free) - бесплатное;
     * D (Demo) - демо-версия;
     * T (Trial) - триальная версия (ограниченная по времени);
     * P (Paid) - оплаченное приложение;
     * L (Local) - локальное приложение.
     * S (Subscription) - подписное приложение.
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInstalled(): bool
    {
        return $this->installed;
    }

    /**
     * @param bool $installed
     * @return $this
     */
    public function setInstalled(bool $installed): self
    {
        $this->installed = $installed;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPaymentExpired(): bool
    {
        return $this->paymentExpired;
    }

    /**
     * @param bool $paymentExpired
     * @return $this
     */
    public function setPaymentExpired(bool $paymentExpired): self
    {
        $this->paymentExpired = $paymentExpired;
        return $this;
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * @param int $days
     * @return $this
     */
    public function setDays(int $days): self
    {
        $this->days = $days;
        return $this;
    }

    /**
     * ru_project - тариф Проект
     * ru_basic - тариф Базовый
     * ru_std - тариф Стандартный
     * ru_pro100 - тариф Профессиональный
     * ru_ent250 - Энтерпрайз 250
     * ru_ent500 - Энтерпрайз 500
     * ru_ent1000 - Энтерпрайз 1000
     * ru_ent2000 - Энтерпрайз 2000
     * ru_ent10000 - Энтерпрайз 10000
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * @param string $license
     * @return $this
     */
    public function setLicense(string $license): self
    {
        $this->license = $license;
        return $this;
    }

    /**
     * @return string
     */
    public function getLicenseType(): string
    {
        return $this->licenseType;
    }

    /**
     * @param string $licenseType
     * @return $this
     */
    public function setLicenseType(string $licenseType): self
    {
        $this->licenseType = $licenseType;
        return $this;
    }

    /**
     * @return string
     */
    public function getLicenseFamily(): string
    {
        return $this->licenseFamily;
    }

    /**
     * @param string $licenseFamily
     * @return $this
     */
    public function setLicenseFamily(string $licenseFamily): self
    {
        $this->licenseFamily = $licenseFamily;
        return $this;
    }

}
