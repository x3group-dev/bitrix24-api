<?php

namespace Bitrix24Api\DTO;

class Time
{
    protected float $start;
    protected float $finish;
    protected float $duration;
    protected float $processing;
    protected float $operating;
    protected ?int $operatingResetAt;
    protected \DateTimeImmutable $dateStart;
    protected \DateTimeImmutable $dateFinish;

    /**
     * Time constructor.
     *
     * @param float $start
     * @param float $finish
     * @param float $duration
     * @param float $processing
     * @param \DateTimeImmutable $dateStart
     * @param \DateTimeImmutable $dateFinish
     */
    public function __construct(
        float              $start,
        float              $finish,
        float              $duration,
        float              $processing,
        float              $operating,
        ?int               $operatingResetAt,
        \DateTimeImmutable $dateStart,
        \DateTimeImmutable $dateFinish
    )
    {
        $this->start = $start;
        $this->finish = $finish;
        $this->duration = $duration;
        $this->processing = $processing;
        $this->operating = $operating;
        $this->operatingResetAt = $operatingResetAt;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
    }

    /**
     * @param array $response
     *
     * @return self
     * @throws \Exception
     */
    public static function initFromResponse(array $response): self
    {
        return new self(
            (float)$response['start'],
            (float)$response['finish'],
            (float)$response['duration'],
            (float)$response['processing'],
            (float)($response['operating'] ?? 0),
            isset($response['operating_reset_at']) ? (int)$response['operating_reset_at'] : null,
            new \DateTimeImmutable($response['date_start']),
            new \DateTimeImmutable($response['date_finish'])
        );
    }

    /**
     * @return float
     */
    public function getStart(): float
    {
        return $this->start;
    }

    /**
     * @return float
     */
    public function getFinish(): float
    {
        return $this->finish;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @return float
     */
    public function getProcessing(): float
    {
        return $this->processing;
    }

    public function getOperating(): float
    {
        return $this->operating;
    }

    public function getOperatingResetAt(): ?int
    {
        return $this->operatingResetAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateStart(): \DateTimeImmutable
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateFinish(): \DateTimeImmutable
    {
        return $this->dateFinish;
    }
}
