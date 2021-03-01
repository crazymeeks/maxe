<?php

namespace App\Models\Api;

interface AnnouncementInterface
{

    const ID = 'id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const STATUS = 'active';

    /**
     * Set announcement id
     *
     * @param integer $id
     * 
     * @return $this
     */
    public function setId(int $id);

    /**
     * Set announcement title
     *
     * @param string $title
     * 
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Set announcement content
     *
     * @param string $content
     * 
     * @return $this
     */
    public function setContent(string $content);

    /**
     * Set start date
     *
     * @param string $start_date
     * 
     * @return $this
     */
    public function setStartDate(string $start_date);

    /**
     * Set end date
     *
     * @param string $end_date
     * 
     * @return $this
     */
    public function setEndDate(string $end_date);

    /**
     * Set announcement status
     *
     * @param integer $status 1=active;0=inactive
     * 
     * @return $this
     */
    public function setStatus(int $status = 0);


    /**
     * Get announcement id
     *
     * @return int
     */
    public function getId();

    /**
     * Get announcement title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get announcement content
     *
     * @return string
     */
    public function getContent();

    /**
     * Get announcement start date
     *
     * @return string
     */
    public function getStartDate();

    /**
     * Get announcement end date
     *
     * @return string
     */
    public function getEndDate();

    /**
     * Get announcement status
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get announcement data as array
     *
     * @return array
     */
    public function toArray(): array;
}