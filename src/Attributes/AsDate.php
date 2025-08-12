<?php

namespace KiloSierraCharlie\VATSIM\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class AsDate
{
    /**
     * @param string|\DateTimeZone|null $timezone accepts both TZ string and object
     */
    public function __construct(
        public string $format = 'Y-m-d',
        public bool $yearMonth = false,
        public string|\DateTimeZone|null $timezone = null,
    ) {
        if (is_string($this->timezone)) {
            try {
                $this->timezone = new \DateTimeZone($this->timezone);
            } catch (\Exception $e) {
                $this->timezone = null;
            }
        }
    }

    public function transform(mixed $value): ?\DateTimeImmutable
    {
        if (!$value) {
            return null;
        }

        $value = (string) $value;
        $tz = $this->timezone instanceof \DateTimeZone ? $this->timezone : null;

        if ($this->yearMonth) {
            $dt = \DateTimeImmutable::createFromFormat('!Y-m', $value, $tz);
            if (!$dt) {
                return null;
            }

            return $dt->setDate((int) $dt->format('Y'), (int) $dt->format('m'), 1);
        }

        return \DateTimeImmutable::createFromFormat('!'.$this->format, $value, $tz) ?: null;
    }
}
