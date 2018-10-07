<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 2/3/15
 * Time: 3:16 PM
 */

$transient_feed_tweet = 'transient_feed_tweet';

if($time_to_store!='' && is_numeric($time_to_store))
    $fetchedTweets = get_transient($transient_feed_tweet);
else
    delete_transient($transient_feed_tweet);

$twitterClient = new TwitterClient(trim($twitter_consumer_key), trim($twitter_consumer_secret), trim($twitter_access_token), trim($twitter_access_token_secret));
if(!isset($fetchedTweets) || !$fetchedTweets){
    $fetchedTweets = $twitterClient->getTweet(trim($twitter_user_name),$total_feed);
    if($time_to_store!='' && is_numeric($time_to_store))
        set_transient($transient_feed_tweet, $fetchedTweets, 60 * $time_to_store);
}

?>

<div class="ryl-color-light ryl-twitter">
        <div class="ryl-margin-top-90"></div>
        <div class="ryl-section-item">
            <div class="ryl-fullwidth-carousel ryl-twitter-rss-carousel has-dots owl-carousel"
                 data-plugin-options='{"items" : 1,"pagination": <?php if($paging_style=='dot') { echo "true";} else { echo "false";} ?>, "nav" : <?php if($paging_style!='dot') { echo "true";} else { echo "false";} ?>, "singleItem" : true}'
                >
                <?php
                if($fetchedTweets!=''){
                    $limitToDisplay = min($total_feed, count($fetchedTweets));
                    for($i=0; $i < $limitToDisplay; $i++){
                        $tweet = $fetchedTweets[$i];
                        $name = $tweet->user->name;
                        $screen_name = $tweet->user->screen_name;
                        $permalink = 'http://twitter.com/'. $name .'/status/'. $tweet->id_str;
                        $tweet_id = $tweet->id_str;
                        $text = $twitterClient->sanitize_links($tweet);
                        $time = $tweet->created_at;
                        $time = date_parse($time);
                        $uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);
                        if($text!=''){
                            ?>
                            <div class="ryl-twitter-rss-item">
                                <div class="ryl-logo"><i class="icon-twitter"></i></div>
                                <div class="ryl-content">
                                    <p><?php echo wp_kses_post($text);?></p>
                                </div>
                                <div class="ryl-info">
                                    <div class="ryl-time"><?php $twitterClient->get_the_time($uTime) ?> </div>
                                </div>
                            </div>
                        <?php   }
                    }
                }else{
                    ?>
                    <p class="twitter-error"><?php echo esc_html__("Could not authenticate you","g5plus-academia") ?></p>
                <?php } ?>
            </div>
        </div>

    </div>


