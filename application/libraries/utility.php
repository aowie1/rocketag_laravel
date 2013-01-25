<?php
class Utility
{
    /**
     * This expands upon the idea of Laravel's native sync() method
     * The difference is that this method allows you to sync multiple ids
     * into a pivot table but also pass along persistent variables to
     * each pivot row. i.e. user_ids, lang_keys, etc.
     *
     * @param object $object
     * @param string $ref_table
     * @param integer[] $ids
     * @param string[] $static_vals
     * @return void
     */
    public static function sync_with_static($object, $ref_table, $ids, $static_vals = array())
    {
        $current_objects = (array) $object->{$ref_table};

        $current = array();

        foreach ($current_objects as $obj)
        {
            $current[] = $obj->id;
        }

        foreach ($ids as $id)
        {
            if ( ! in_array($id, $current))
            {
                $object->tags()->attach($id, $static_vals);
            }
        }

        $detach = array_diff($current, $ids);

        if (count($detach) > 0)
        {
            $object->tags()->detach($detach);
        }
    }
}