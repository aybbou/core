<?php

use Vespolina\Entity\Item;
/**
 * @author Richard Shank <develop@zestic.com>
 */
class ItemTest
{
    public function testOptionMethods()
    {
        $item = new Item();

        $this->assertNull($item->getOption('noOption'));

        $rmAddOption = new \ReflectionMethod($item, 'addOption');
        $rmAddOption->invoke($item, array('option1', 1));
        $this->assertCount(1, $item->getOptions());
        $this->assertSame(1, $item->getOption('option1'));

        $rmAddOption->invoke($item, array('option2', 2));
        $this->assertCount(2, $item->getOptions());
        $this->assertSame(2, $item->getOption('option2'));

        $rmRemoveOption = new \ReflectionMethod($item, 'removeOption');
        $rmRemoveOption->invoke($item, 'option2');
        $this->assertCount(1, $item->getOptions(), 'remove by option');
        $this->assertNull($item->getOption('option2'));

        $options = array(
            'option2' => 2,
            'option3' => 3
        );

        $rmAddOptions = new \ReflectionMethod($item, 'addOptions');
        $rmAddOptions->invoke($item, $options);
        $this->assertCount(3, $item->getOptions());
        $this->assertSame(2, $item->getOption('option2'));
        $this->assertSame(3, $item->getOption('option3'));

        $rmSetOptions = new \ReflectionMethod($item, 'setOptions');
        $rmSetOptions->invoke($item, $options);
        $this->assertCount(2, $item->getOptions());
        $this->assertNull($item->getOption('option1'));
        $this->assertSame(2, $item->getOption('option2'));
        $this->assertSame(3, $item->getOption('option3'));

        $rmRemoveOption->invoke($item, 'option3');
        $this->assertCount(1, $item->getOptions(), 'option should be removed by type');

        $rmRemoveOption->invoke($item, 'nada');
        $this->assertCount(1, $item->getOptions());

        $rmClearOptions = new \ReflectionMethod($item, 'clearOptions');
        $rmClearOptions->invoke($item);
        $this->assertEmpty($item->getOptions());
    }
}
