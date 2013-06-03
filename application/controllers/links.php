<?php
/*
|--------------------------------------------------------------------------
| The Links Controller
|--------------------------------------------------------------------------
*/
class Links_Controller extends Base_Controller
{
    public $restful = true;

    public function post_create()
    {
        $link = new Link;

        if ($link->create_link()) {

            if (Request::ajax()) {
                return View::make('links.result')
                    ->with('link', $link);
            } else {
                $success = 'Your link was successfully created!';

                // Return to the same page with a success message
                return View::make('links.add')
                    ->with('success', $success);
            }
        } else {

            // Return to the same page with error messages
            return Redirect::to('/links')
                ->with_input()
                ->with_errors($link->errors);
        }
    }
}