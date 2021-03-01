<?php

namespace App\Models\Data;

use App\Models\Api\AnnouncementInterface;

class AnnouncementData implements AnnouncementInterface
{

    
    private $_data = [];


    /**
     * @implement
     */
    public function setId(int $id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @implement
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @implement
     */
    public function setContent(string $content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @implement
     */
    public function setStartDate(string $start_date)
    {
        return $this->setData(self::START_DATE, $start_date);
    }

    /**
     * @implement
     */
    public function setEndDate(string $end_date)
    {
        return $this->setData(self::END_DATE, $end_date);
    }

    /**
     * @implement
     */
    public function setStatus(int $status = 0)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @implement
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @implement
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @implement
     */
    public function getStartDate()
    {
        return $this->getData(self::START_DATE);
    }

    /**
     * @implement
     */
    public function getEndDate()
    {
        return $this->getData(self::END_DATE);
    }

    /**
     * @implement
     */
    public function getStatus(): int
    {
        
        // $exploded = explode(' ', $this->getStartDate());
        
        // automatically set to active based on start date
        // list($date, $time) = $exploded;
        $date = $this->getStartDate();
        if ($date <= date('Y-m-d')) {
            return 1;
        }

        return $this->getData(self::STATUS) ?? 0;
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set data
     *
     * @param string $key
     * @param mixed $value
     * 
     * @return $this
     */
    public function setData(string $key, $value)
    {

        $this->_data[$key] = $value;
        return $this;
    }

    public function getData(string $key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

    /**
     * @implement
     */
    public function toArray(): array
    {
        
        return [
            self::TITLE => $this->getTitle(),
            self::CONTENT => $this->getContent(),
            self::START_DATE => $this->getStartDate(),
            self::END_DATE => $this->getEndDate(),
            self::STATUS => $this->getStatus(),
        ];
    }
}