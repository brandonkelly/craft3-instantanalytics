<?php
/**
 * Instant Analytics plugin for Craft CMS 3.x
 *
 * Instant Analytics brings full Google Analytics support to your Twig templates
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\instantanalytics\variables;

use nystudio107\instantanalytics\InstantAnalytics;
use nystudio107\instantanalytics\helpers\IAnalytics;

use Craft;

/**
 * Instant Analytics Variable
 *
 * @author    nystudio107
 * @package   InstantAnalytics
 * @since     1.0.0
 */
class InstantAnalyticsVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Get a PageView analytics object
     *
     * @param string $url
     * @param string $title
     *
     * @return IAnalytics object
     */
    public function pageViewAnalytics($url = "", $title = "")
    {
        return InstantAnalytics::$plugin->ia->pageViewAnalytics($url, $title);
    }

    /**
     * Get an Event analytics object
     *
     * @param string $eventCategory
     * @param string $eventAction
     * @param string $eventLabel
     * @param int    $eventValue
     *
     * @return null|IAnalytics
     */
    public function eventAnalytics($eventCategory = "", $eventAction = "", $eventLabel = "", $eventValue = 0)
    {
        return InstantAnalytics::$plugin->ia->eventAnalytics($eventCategory, $eventAction, $eventLabel, $eventValue);
    }

    /**
     * Return an Analytics object
     */
    public function analytics()
    {
        return InstantAnalytics::$plugin->ia->analytics();
    }

    /**
     * Get a PageView tracking URL
     *
     * @param  string $url   the URL to track
     * @param  string $title the page title
     *
     * @return string the tracking URL
     */
    public function pageViewTrackingUrl($url, $title)
    {
        return InstantAnalytics::$plugin->ia->pageViewTrackingUrl($url, $title);
    }

    /**
     * Get an Event tracking URL
     *
     * @param  string $url           the URL to track
     * @param  string $eventCategory the event category
     * @param  string $eventAction   the event action
     * @param  string $eventLabel    the event label
     * @param  int    $eventValue    the event value
     *
     * @return string the tracking URL
     */
    public function eventTrackingUrl($url, $eventCategory = "", $eventAction = "", $eventLabel = "", $eventValue = 0)
    {
        return InstantAnalytics::$plugin->ia->eventTrackingUrl($url, $eventCategory, $eventAction, $eventLabel, $eventValue);
    }
}
