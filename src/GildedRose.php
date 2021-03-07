<?php

namespace App;

class GildedRose
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]);
    }

    public function nextDay()
    {
        foreach ($this->items as $item) {

            /**
             * Aged Brie and Backstage Passes are special items which
             * increase in value/quality as sellIn approaches.
             */
            if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > 0) {

                    /**
                     * Sulfuras never has to be sold and never
                     * decreases in quality
                     */
                    if ($item->name != 'Sulfuras, Hand of Ragnaros') {

                        /**
                         * Standard items lose 1 quality per day
                         */
                        $item->quality = $item->quality - 1;
                    }
                }
            } else {

                /**
                 * Non-legendary items can never have quality
                 * above 50.
                 * 
                 * Sulfuras has a fixed quality of 80,
                 * so we don't need to apply any
                 * incrementing/decrementing there.
                 */
                if ($item->quality < 50) {

                    /**
                     * Increase item quality by 1
                     */
                    $item->quality = $item->quality + 1;

                    /**
                     * Backstage passes are a special item whose quality:
                     * 
                     * - Increases by 2 per day when 10 or fewer days left
                     * - Increases by 3 per day when 5 or fewer days left
                     * - Drops to 0 after sellIn
                     */
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {

                        /**
                         * 10 or fewer days remaining, so increase quality
                         * by additional 1 - this will total 2 due
                         * to above increment
                         */
                        if ($item->sellIn < 11) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }

                        /**
                         * 5 or fewer days remaining, so increase quality
                         * by additional 1 - this will total 3 due
                         * to above increments
                         */
                        if ($item->sellIn < 6) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }

            /**
             * Sulfuras is a special item which never changes
             * sellIn (never needs to be sold)
             */
            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sellIn = $item->sellIn - 1;
            }

            /**
             * If sellIn is less than 0, the item
             * is past its sell-by date.
             * 
             * For standard items, this means quality
             * degrades twice as fast. We've already reduced
             * quality by 1 above, so just reduce by another
             * 1.
             * 
             * Aged Brie, Backstage Passes and Sulfuras are special items,
             * so we treat them a little differently:
             * 
             * - Aged Brie only ever increases in quality, until
             *   the standard item cap of 50
             * 
             * - If Backstage Passes have passed their sell-by date,
             *   the concert has passed, so they lose all their value
             * 
             * - Sulfuras has a fixed quality of 80 and never needs to
             *   be sold, so we don't need to worry about the sell-by
             *   date there.
             */
            if ($item->sellIn < 0) {

                /**
                 * If we're dealing with Aged Brie, use some
                 * alternative logic as it never decreases in quality
                 */
                if ($item->name != 'Aged Brie') {

                    /**
                     * If we're dealing with Backstage Passes, use
                     * some alternative logic as they lose all their
                     * value (quality) after the concert
                     */
                    if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {

                        /**
                         * Quality of an item can never be negative, so
                         * we only need to decrement if quality is greater
                         * than 0
                         */
                        if ($item->quality > 0) {

                            /**
                             * Sulfuras has a fixed quality of 80, so
                             * only decrement if we're not dealing with
                             * Sulfuras.
                             */
                            if ($item->name != 'Sulfuras, Hand of Ragnaros') {

                                /**
                                 * Decrement quality by additional 1,
                                 * this effectively doubles the rate
                                 * of degradation after the sell-by date
                                 * as we've already decremented by 1 by
                                 * this point.
                                 */
                                $item->quality = $item->quality - 1;
                            }
                        }
                    } else {

                        /**
                         * Backstage Passes lose all their value/quality
                         * after the concert
                         */
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {

                    /**
                     * Aged Brie only ever increases in quality
                     */
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }
}