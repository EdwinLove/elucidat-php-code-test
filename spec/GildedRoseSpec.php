<?php

use App\BackstagePass;
use App\BasicItem;
use App\ConjurableItem;
use App\Item;
use App\GildedRose;
use App\LegendaryItem;
use App\MaturingItem;

describe('Gilded Rose', function () {
    describe('next day', function () {
        context('normal Items', function () {
            it('updates normal items before sell date', function () {
                $gr = new GildedRose([new Item('normal', 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(9);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates normal items on the sell date', function () {
                $gr = new GildedRose([new Item('normal', 10, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(8);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates normal items after the sell date', function () {
                $gr = new GildedRose([new Item('normal', 10, -5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(8);
                expect($gr->getItem(0)->sellIn)->toBe(-6);
            });
            it('updates normal items with a quality of 0', function () {
                $gr = new GildedRose([new Item('normal', 0, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
        });
        context('Brie Items', function () {
            it('updates Brie items before the sell date', function () {
                $gr = new GildedRose([new Item('Aged Brie', 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(11);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Brie items before the sell date with maximum quality', function () {
                $gr = new GildedRose([new Item('Aged Brie', 50, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Brie items on the sell date', function () {
                $gr = new GildedRose([new Item('Aged Brie', 10, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(12);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Brie items on the sell date, near maximum quality', function () {
                $gr = new GildedRose([new Item('Aged Brie', 49, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Brie items on the sell date with maximum quality', function () {
                $gr = new GildedRose([new Item('Aged Brie', 50, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Brie items after the sell date', function () {
                $gr = new GildedRose([new Item('Aged Brie', 10, -10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(12);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
            it('updates Brie items after the sell date with maximum quality', function () {
                $gr = new GildedRose([new Item('Aged Brie', 50, -10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
        });
        context('Sulfuras Items', function () {
            it('updates Sulfuras items before the sell date', function () {
                $gr = new GildedRose([new Item('Sulfuras, Hand of Ragnaros', 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(10);
                expect($gr->getItem(0)->sellIn)->toBe(5);
            });
            it('updates Sulfuras items on the sell date', function () {
                $gr = new GildedRose([new Item('Sulfuras, Hand of Ragnaros', 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(10);
                expect($gr->getItem(0)->sellIn)->toBe(5);
            });
            it('updates Sulfuras items after the sell date', function () {
                $gr = new GildedRose([new Item('Sulfuras, Hand of Ragnaros', 10, -1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(10);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
        });
        context('Backstage Passes', function () {
            it('updates Backstage pass items long before the sell date', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 10, 11)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(11);
                expect($gr->getItem(0)->sellIn)->toBe(10);
            });
            it('updates Backstage pass items close to the sell date', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 10, 10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(12);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Backstage pass items close to the sell data, at max quality', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 50, 10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Backstage pass items very close to the sell date', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 10, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(13); // goes up by 3
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Backstage pass items very close to the sell date, at max quality', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 50, 5)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(4);
            });
            it('updates Backstage pass items with one day left to sell', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 10, 1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(13);
                expect($gr->getItem(0)->sellIn)->toBe(0);
            });
            it('updates Backstage pass items with one day left to sell, at max quality', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 50, 1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(50);
                expect($gr->getItem(0)->sellIn)->toBe(0);
            });
            it('updates Backstage pass items on the sell date', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 10, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Backstage pass items after the sell date', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 10, -1)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-2);
            });
        });

        /**
         * Conjured Items Tests - I thought I was going to need to do some
         * more work to make these pass but looks like I did a pretty good job
         * when accounting for the new type when refactoring!
         */
        context("Conjured Items", function () {
            it('updates Conjured items before the sell date', function () {
                $gr = new GildedRose([new Item('Conjured Mana Cake', 10, 10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(8);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Conjured items at zero quality', function () {
                $gr = new GildedRose([new Item('Conjured Mana Cake', 0, 10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(9);
            });
            it('updates Conjured items on the sell date', function () {
                $gr = new GildedRose([new Item('Conjured Mana Cake', 10, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(6);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Conjured items on the sell date at 0 quality', function () {
                $gr = new GildedRose([new Item('Conjured Mana Cake', 0, 0)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-1);
            });
            it('updates Conjured items after the sell date', function () {
                $gr = new GildedRose([new Item('Conjured Mana Cake', 10, -10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(6);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
            it('updates Conjured items after the sell date at zero quality', function () {
                $gr = new GildedRose([new Item('Conjured Mana Cake', 0, -10)]);
                $gr->nextDay();
                expect($gr->getItem(0)->quality)->toBe(0);
                expect($gr->getItem(0)->sellIn)->toBe(-11);
            });
        });

        /**
         * Additional tests
         */
        context("Gilded Rose Instantiation Tests", function () {
            it('returns a LegendaryItem when passed correct name', function () {
                $gr = new GildedRose([new Item('Sulfuras, Hand of Ragnaros', 10, 10)]);
                expect($gr->getItem(0))->toBeAnInstanceOf(LegendaryItem::class);
            });
            it('returns a MaturingItem when passed correct name', function () {
                $gr = new GildedRose([new Item('Aged Brie', 10, 10)]);
                expect($gr->getItem(0))->toBeAnInstanceOf(MaturingItem::class);
            });
            it('returns a ConjurableItem when passed correct name', function () {
                $gr = new GildedRose([new Item('Conjured Mana Cake', 10, 10)]);
                expect($gr->getItem(0))->toBeAnInstanceOf(ConjurableItem::class);
            });
            it('returns a BackstagePass when passed correct name', function () {
                $gr = new GildedRose([new Item('Backstage passes to a TAFKAL80ETC concert', 10, 10)]);
                expect($gr->getItem(0))->toBeAnInstanceOf(BackstagePass::class);
            });
            it('returns a BasicItem when passed correct name', function () {
                $gr = new GildedRose([new Item('Beans on Toast', 10, 10)]);
                expect($gr->getItem(0))->toBeAnInstanceOf(BasicItem::class);
            });
        });
    
        context("BasicItem tests", function () {
            it('BasicItem with 50 quality can be degraded', function () {
                $item = new BasicItem(
                    new Item('Beans on Toast', 50, 100)
                );
                
                expect($item->canDegradeFurther())->toBe(true);
            });

            it('BasicItem with 0 quality cannot be degraded', function () {
                $item = new BasicItem(
                    new Item('Beans on Toast', 0, 100)
                );
                
                expect($item->canDegradeFurther())->toBe(false);
            });

            it('BasicItem past sell-by date has degrade amount of 2', function () {
                $item = new BasicItem(
                    new Item('Beans on Toast', 10, -100)
                );
                
                expect($item->getDegradationAmount())->toBe(2);
            });

            it('BasicItem past sell-by date with 1 quality degrades to 0', function () {
                $item = new BasicItem(
                    new Item('Beans on Toast', 1, -100)
                );

                $item->degrade();
                
                expect($item->quality)->toBe(0);
            });

            it('BasicItem past sell-by date with 2 quality degrades to 0', function () {
                $item = new BasicItem(
                    new Item('Beans on Toast', 2, -100)
                );

                $item->degrade();
                
                expect($item->quality)->toBe(0);
            });

            it('BasicItem before sell-by date has degrade amount of 1', function () {
                $item = new BasicItem(
                    new Item('Beans on Toast', 10, 100)
                );
                
                expect($item->getDegradationAmount())->toBe(1);
            });
        });

        context("MaturingItem tests", function () {
            it('MaturingItem with 50 quality cannot be degraded', function () {
                $item = new MaturingItem(
                    new Item('Beans on Toast', 50, 100)
                );

                expect($item->canDegradeFurther())->toBe(false);
            });

            it('MaturingItem with 0 quality can be degraded', function () {
                $item = new MaturingItem(
                    new Item('Beans on Toast', 0, 100)
                );

                expect($item->canDegradeFurther())->toBe(true);
            });

            it('MaturingItem past sell-by date has degrade amount of -2', function () {
                $item = new MaturingItem(
                    new Item('Beans on Toast', 10, -100)
                );

                expect($item->getDegradationAmount())->toBe(-2);
            });

            it('MaturingItem past sell-by date with 49 quality degrades to 50', function () {
                $item = new MaturingItem(
                    new Item('Beans on Toast', 49, -100)
                );

                $item->degrade();

                expect($item->quality)->toBe(50);
            });

            it('MaturingItem past sell-by date with 48 quality degrades to 50', function () {
                $item = new MaturingItem(
                    new Item('Beans on Toast', 48, -100)
                );

                $item->degrade();

                expect($item->quality)->toBe(50);
            });

            it('MaturingItem before sell-by date has degrade amount of -1', function () {
                $item = new MaturingItem(
                    new Item('Beans on Toast', 10, 100)
                );

                expect($item->getDegradationAmount())->toBe(-1);
            });
        });

        context("BackstagePass tests", function () {
            it('BackstagePass with 50 quality cannot be degraded', function () {
                $item = new BackstagePass(
                    new Item('Beans on Toast', 50, 100)
                );

                expect($item->canDegradeFurther())->toBe(false);
            });

            it('BackstagePass with 0 quality can be degraded', function () {
                $item = new BackstagePass(
                    new Item('Beans on Toast', 0, 100)
                );

                expect($item->canDegradeFurther())->toBe(true);
            });

            it('BackstagePass 15 days before sell-by date has degrade amount of -1', function () {
                $item = new BackstagePass(
                    new Item('Beans on Toast', 10, 15)
                );

                expect($item->getDegradationAmount())->toBe(-1);
            });

            it('BackstagePass 6 days before sell-by date has degrade amount of -2', function () {
                $item = new BackstagePass(
                    new Item('Beans on Toast', 10, 6)
                );

                expect($item->getDegradationAmount())->toBe(-2);
            });

            it('BackstagePass 0 days before sell-by date has degrade amount of -3', function () {
                $item = new BackstagePass(
                    new Item('Beans on Toast', 10, 0)
                );

                expect($item->getDegradationAmount())->toBe(-3);
            });

            it('BackstagePass past sell-by date with 50 quality degrades to 0', function () {
                $item = new BackstagePass(
                    new Item('Beans on Toast', 50, -100)
                );

                $item->degrade();

                expect($item->quality)->toBe(0);
            });
        });

        context("LegendaryItem tests", function () {
            it('LegendaryItem is not degradable', function () {
                $item = new LegendaryItem(
                    new Item('Beans on Toast', 50, 100)
                );

                expect($item->isDegradable())->toBe(false);
            });

            it('LegendaryItem does not need to be sold', function () {
                $item = new LegendaryItem(
                    new Item('Beans on Toast', 50, 100)
                );

                expect($item->needsToBeSold())->toBe(false);
            });
        });

        context("ConjurableItem tests", function () {
            it('ConjurableItem with 50 quality can be degraded', function () {
                $item = new ConjurableItem(
                    new Item('Beans on Toast', 50, 100)
                );

                expect($item->canDegradeFurther())->toBe(true);
            });

            it('ConjurableItem with 0 quality cannot be degraded', function () {
                $item = new ConjurableItem(
                    new Item('Beans on Toast', 0, 100)
                );

                expect($item->canDegradeFurther())->toBe(false);
            });

            it('ConjurableItem past sell-by date has degrade amount of 4', function () {
                $item = new ConjurableItem(
                    new Item('Beans on Toast', 10, -100)
                );

                expect($item->getDegradationAmount())->toBe(4);
            });

            it('ConjurableItem past sell-by date with 1 quality degrades to 0', function () {
                $item = new ConjurableItem(
                    new Item('Beans on Toast', 1, -100)
                );

                $item->degrade();

                expect($item->quality)->toBe(0);
            });

            it('ConjurableItem past sell-by date with 4 quality degrades to 0', function () {
                $item = new ConjurableItem(
                    new Item('Beans on Toast', 2, -100)
                );

                $item->degrade();

                expect($item->quality)->toBe(0);
            });

            it('ConjurableItem before sell-by date has degrade amount of 2', function () {
                $item = new ConjurableItem(
                    new Item('Beans on Toast', 10, 100)
                );

                expect($item->getDegradationAmount())->toBe(2);
            });
        });
    });
});
