<?php

namespace Manoar\QrCode\DataTypes;

use InvalidArgumentException;

class Calendar implements DataTypeInterface
{
    protected string $summary = '';
    protected string $startDateTime = '';
    protected string $endDateTime = '';
    protected string $location = '';
    protected string $description = '';
    protected string $url = '';

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * Accepts a single associative array with keys:
     *   summary (required), start (required, ISO 8601 or YYYYMMDDTHHMMSS),
     *   end (required), location, description, url.
     *
     * @param array $arguments
     * @throws InvalidArgumentException
     */
    public function create(array $arguments)
    {
        $args = $arguments[0] ?? $arguments;

        if (empty($args['summary'])) {
            throw new InvalidArgumentException('Calendar event requires a summary.');
        }
        if (empty($args['start'])) {
            throw new InvalidArgumentException('Calendar event requires a start date/time.');
        }
        if (empty($args['end'])) {
            throw new InvalidArgumentException('Calendar event requires an end date/time.');
        }

        $this->summary = $args['summary'];
        $this->startDateTime = $this->formatDateTime($args['start']);
        $this->endDateTime = $this->formatDateTime($args['end']);

        if (isset($args['location'])) {
            $this->location = $args['location'];
        }
        if (isset($args['description'])) {
            $this->description = $args['description'];
        }
        if (isset($args['url'])) {
            $this->url = $args['url'];
        }
    }

    /**
     * Returns the iCalendar (vEvent) formatted string.
     *
     * @return string
     */
    public function __toString()
    {
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'BEGIN:VEVENT',
            'SUMMARY:'.$this->summary,
            'DTSTART:'.$this->startDateTime,
            'DTEND:'.$this->endDateTime,
        ];

        if ($this->location !== '') {
            $lines[] = 'LOCATION:'.$this->location;
        }
        if ($this->description !== '') {
            $lines[] = 'DESCRIPTION:'.$this->description;
        }
        if ($this->url !== '') {
            $lines[] = 'URL:'.$this->url;
        }

        $lines[] = 'END:VEVENT';
        $lines[] = 'END:VCALENDAR';

        return implode("\n", $lines);
    }

    /**
     * Normalises a date/time string to iCal YYYYMMDDTHHMMSS format.
     *
     * @param string $dateTime
     * @return string
     */
    protected function formatDateTime(string $dateTime): string
    {
        // Already in iCal format (e.g. 20240101T120000 or 20240101T120000Z)
        if (preg_match('/^\d{8}T\d{6}Z?$/', $dateTime)) {
            return $dateTime;
        }

        $ts = strtotime($dateTime);
        if ($ts === false) {
            throw new InvalidArgumentException("Invalid date/time: {$dateTime}");
        }

        return gmdate('Ymd\THis\Z', $ts);
    }
}
