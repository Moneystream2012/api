<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tarasenko Andrii
 * Date: 01.08.17
 * Time: 11:44
 */

namespace tests\_support\fixtures;

/**
 * Interface FixturesInterface
 */
interface FixturesInterface
{
    //public function getMergedFixturesData();

    /**
     * @return array
     */
    public function getDefaultValuesByFields();
}
