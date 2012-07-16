<?php
/**
 * File containing the eZPublish UrlHandler class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\API\REST\Common\UrlHandler;

use eZ\Publish\API\REST\Common\UrlHandler;
use eZ\Publish\API\REST\Common\Exceptions;

/**
 * Pattern based URL Handler pre-configured for eZ Publish
 */
class eZPublish extends Pattern
{
    /**
     * Map of URL types to their URL patterns
     *
     * @var array
     * @TODO: Add sensible missing names
     */
    protected $map = array(
        ''                    => '/',
        ''                    => '/content/locations',
        'location'            => '/content/locations/{location}',
        ''                    => '/content/locations/{location}/children',
        'objects'             => '/content/objects',
        'objectByRemote'      => '/content/objects?remoteId={object}',
        'object'              => '/content/objects/{object}',
        ''                    => '/content/objects/{object}/currentversion',
        ''                    => '/content/objects/{object}/{lang_code}',
        ''                    => '/content/objects/{object}/locations',
        ''                    => '/content/objects/{object}/versions',
        ''                    => '/content/objects/{object}/versions/{version}',
        ''                    => '/content/objects/{object}/versions/{version}/relations',
        ''                    => '/content/objects/{object}/versions/{version}/relations/{relation}',
        'sections'            => '/content/sections',
        'section'             => '/content/sections/{section}',
        'sectionByIdentifier' => '/content/sections?identifier={section}',
        ''                    => '/content/trash',
        'trash'               => '/content/trash/{trash}',
        ''                    => '/content/typegroups',
        'typegroup'           => '/content/typegroups/{typegroup}',
        ''                    => '/content/typegroups/{typegroup}/types',
        'types'               => '/content/types',
        'type'                => '/content/types/{type}',
        ''                    => '/content/types/{type}/draft',
        ''                    => '/content/types/{type}/draft/fieldDefinitions',
        ''                    => '/content/types/{type}/draft/fieldDefinitions/{fieldDefinition}',
        ''                    => '/content/types/{type}/groups',
        ''                    => '/content/types/{type}/groups/{group}',
        ''                    => '/content/views',
        ''                    => '/content/views/{view}',
        ''                    => '/content/views/{view}/results',
        ''                    => '/user/groups',
        'group'               => '/user/groups/{group}',
        ''                    => '/user/groups/{group}/roles',
        ''                    => '/user/groups/{group}/roles/{role}',
        ''                    => '/user/groups/{group}/subgroups',
        ''                    => '/user/groups/{group}/users',
        ''                    => '/user/groups/root',
        'roles'               => '/user/roles',
        'role'                => '/user/roles/{role}',
        'roleByIdentifier'    => '/user/roles?identifier={role}',
        'policies'            => '/user/roles/{role}/policies',
        'policy'              => '/user/roles/{role}/policies/{policy}',
        ''                    => '/user/users',
        'user'                => '/user/users/{user}',
        ''                    => '/user/users/{user}/drafts',
        ''                    => '/user/users/{user}/groups',
        ''                    => '/user/users/{user}/roles',
        ''                    => '/user/users/{user}/roles/{role}',
    );
}

