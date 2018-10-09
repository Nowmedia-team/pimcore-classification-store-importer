<?php
/**
 * @category    ClassificationstoreBundle
 * @date        27/09/2018 10:15
 * @author      Wojciech Peisert <wpeisert@divante.co>
 * @copyright   Copyright (c) 2018 Divante Ltd. (https://divante.co/)
 */

namespace Divante\ClassificationstoreBundle\Import\Item;

use Divante\ClassificationstoreBundle\Constants;
use Divante\ClassificationstoreBundle\Import\Interfaces\ItemInterface;

/**
 * Class Group
 * @package Divante\ClassificationstoreBundle\Import\Item
 */
class Group extends AbstractItem implements ItemInterface
{
    /**
     *
     */
    public function save(): void
    {
        $name = $this->getName();
        $store = $this->getStore();
        $groupConfig = $this->groupRepository->getByNameOrCreate($name, $store);
        $groupConfig->setDescription($this->getDescription());

        $keys = $this->get(Constants::KEYS);
        if (trim($keys)) {
            foreach (explode(Constants::DELIMITER, $keys) as $key) {
                $this->groupRepository->addKeyToGroup(trim($key), $name, $store);
            }
        }

        $groupConfig->save();
    }
}
