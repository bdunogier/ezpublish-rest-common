<?php
/**
 * Interface for observer, extended with support for certain events.
 * $event = 'update' means basically "updated" just as in normal observer code.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2.0
 * @package ezp
 * @subpackage base
 */

namespace ezp\Base\Interfaces;

/**
 * Interface for Observers
 *
 * @package ezp
 * @subpackage base
 */
interface Observer// extends \SplObserver
{
    /**
     * Called when subject has been updated
     *
     * @param Observable $subject
     * @param string $event
     * @return Observer
     */
    public function update( Observable $subject, $event = 'update' );
}