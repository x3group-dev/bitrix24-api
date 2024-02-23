<?php

namespace Bitrix24Api\Models;

use Bitrix24Api\Exceptions\InvalidArgumentException;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class ProfileModel extends AbstractModel implements HasIdInterface
{
    protected int $id;
    protected int $admin;
    protected string $name;
    protected ?string $lastName;
    protected string $personalGender;
    protected string $personalPhoto;
    protected ?string $timeZone;
    protected ?int $timeZoneOffset;

    /**
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $profile): self
    {
        if (empty($profile['ID'])) {
            throw new InvalidArgumentException('User profile id is empty in ' . json_encode($profile));
        }
        $model = new self($profile);
        $model->setId($profile['ID'])
            ->setAdmin($profile['ADMIN'])
            ->setName($profile['NAME'])
            ->setLastName($profile['LAST_NAME'] ?? '')
            ->setPersonalGender($profile['PERSONAL_GENDER'])
            ->setPersonalPhoto($profile['PERSONAL_PHOTO'] ?? '')
            ->setTimeZone($profile['TIME_ZONE'])
            ->setTimeZoneOffset($profile['TIME_ZONE_OFFSET']);

        return $model;
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'ADMIN' => $this->getAdmin(),
            'NAME' => $this->getName(),
            'LAST_NAME' => $this->getLastName(),
            'PERSONAL_GENDER' => $this->getPersonalGender(),
            'PERSONAL_PHOTO' => $this->getPersonalPhoto(),
            'TIME_ZONE' => $this->getTimeZone(),
            'TIME_ZONE_OFFSET' => $this->getTimeZoneOffset(),
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
     * @return int
     */
    public function getAdmin(): int
    {
        return $this->admin;
    }

    /**
     * @param int $admin
     */
    public function setAdmin(int $admin): self
    {
        $this->admin = $admin;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalGender(): string
    {
        return $this->personalGender;
    }

    /**
     * @param string $personalGender
     */
    public function setPersonalGender(string $personalGender): self
    {
        $this->personalGender = $personalGender;
        return $this;
    }

    /**
     * @return string
     */
    public function getPersonalPhoto(): string
    {
        return $this->personalPhoto;
    }

    /**
     * @param string $personalPhoto
     */
    public function setPersonalPhoto(string $personalPhoto): self
    {
        $this->personalPhoto = $personalPhoto;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    /**
     * @param string $timeZone
     */
    public function setTimeZone(?string $timeZone): self
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeZoneOffset(): ?int
    {
        return $this->timeZoneOffset;
    }

    /**
     * @param int $timeZoneOffset
     */
    public function setTimeZoneOffset(?int $timeZoneOffset): self
    {
        $this->timeZoneOffset = $timeZoneOffset;
        return $this;
    }
}
