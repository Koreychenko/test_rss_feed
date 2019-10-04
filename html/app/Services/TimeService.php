<?php


namespace App\Services;


class TimeService
{

    private $fakeTime;

    /**
     * Fake time constructor.
     * @param null $fakeTime
     * @throws \Exception
     */
    public function __construct($fakeTime = null)
    {
        $this->fakeTime = $fakeTime;
    }

    public function getDate()
    {
        if ($this->fakeTime) {
            try {
                return new \DateTime($this->fakeTime);
            } catch (\Exception $e) {
                return new \DateTime();
            }
        }

        if (defined('FAKE_TIME')) {
            try {
                return new \DateTime(FAKE_TIME);
            } catch (\Exception $e) {
                return new \DateTime();
            }
        }

        return new \DateTime();
    }
}