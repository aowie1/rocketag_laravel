<?php
/**
 * User Metadata Model
 * Notes: Return sentry errors as 'sentry' because it can conflict with the $error for validation.
 * This way we also know the error is from sentry making an attempt at something
 *
 * @author Randen Kelly <aowie1@gmail.com>
 * @since January 10, 2012
 */
class User_Metadata extends Aware
{
    /**
     * Name of the DB table associated with this model
     */
    public static $table = 'users_metadata';

    /**
     * Are standard timestamps(created_at & updated_at) used for this model/table?
     */
    public static $timestamps = true;

    /**
     * Ignore these. We redefine the rules for POST & PUT in their respective method
     * because they are not the same due to the password field being required for one
     * but not the other.
     */
    public static $rules = array();

    /**
     * Constructor
     *
     * @return void
     */
    public function __constructor()
    {
        //
    }
}
