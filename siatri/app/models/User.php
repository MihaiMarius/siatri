<?php

class User extends Eloquent
{
    protected $table = 'users';
    public $timestamps = false;

    public function games(){
        return $this->hasMany('User')->withPivot('score');
    }
        /*
        Returns an with followees
        array element : int user_id, string screen_name
    */
    public function getFollowees(){
           $user = $this;
           $fullFriendList = array();

           $twitterCursor = -1;
           while ($twitterCursor != 0) {
            $friendsListObject = (object)Twitter::friendsList($user->user_id, $user->username,  $twitterCursor, false, true);
            $friendUsers = $friendsListObject->users;

            if(count($friendUsers) != 0)
            {
                foreach ($friendUsers as $twitterUser) {
                    $objUser = (object)$twitterUser;
                    $friendDetails = array(
                        "user_id" => $objUser->id,
                        "username" => $objUser->screen_name,
                        "profileImageSrc" => $objUser->profile_image_url,
                        "twitterUrl" => 'www.twitter.com/'.$objUser->screen_name
                        );
                    array_push($fullFriendList, (object)$friendDetails);
                }
            }
            $twitterCursor = $friendsListObject->next_cursor_str;
        }
        return $fullFriendList;
    }

    /*
    @sumamry Returns all the followers of the user
    */
    public function getFollowers(){
        $user = $this;

        $fullFollowerList = array();

        $twitterCursor = -1;
        while ($twitterCursor != 0) {
            $followersListObject = (object)Twitter::followersList($user->user_id, $user->username, $twitterCursor, false, true);
            $followerUsers = $followersListObject->users;
            if(count($followerUsers) != 0)
            {
                foreach ($followerUsers as $twitterUser) {
                    $objUser = (object)$twitterUser;
                    $followerDetails = array(
                        "user_id" => $objUser->id,
                        "username" => $objUser->screen_name,
                        "profileImageSrc" => $objUser->profile_image_url,
                        "twitterUrl" => 'www.twitter.com/'.$objUser->screen_name
                        );
                    array_push($fullFollowerList, (object)$followerDetails);
                }
            }
            
            $twitterCursor = $followersListObject->next_cursor_str;
        }

        return $fullFollowerList;
    }

    public function tweetInvitation($selectedUserIds){
        Twitter::setOAuthToken($this->oauth_token);
        Twitter::setOAuthTokenSecret($this->oauth_secret);

        if(is_array($selectedUserIds) && count($selectedUserIds) > 0)
        {
            $tagNames = '';
            foreach ($selectedUserIds as $user_id) {
                $user = User::where('oauth_uid', '=', $user_id)->first();

                if(count($user) > 0)
                {
                    $tagNames .=  '@'.$user->username;
                }
            }        

            $tweetMessage = "Message from siatri application, click this: www.siatri.com/gamelobby " . $tagNames;
            try{
                Twitter::statusesUpdate($tweetMessage);
                return true;
            }catch(Exception $e){
                return false;
            }
        }

        return false;
    }
}