<?php 
require 'vendor/autoload.php';
use PicoFeed\Reader\Reader;
 view('layouts/header'); 
 ?>
 
<?php
    
    $reader = new Reader;
    $resource = $reader->download('https://www.theregister.co.uk/software/headlines.atom');

    $parser = $reader->getParser(
        $resource->getUrl(),
        $resource->getContent(),
        $resource->getEncoding()
    );
    $feeds = $parser->execute();
//Read each feed's items
    $entries = array();
    foreach ($feeds->items as $item) {
        $xml[] = $item->xml;
    }
    $entries = array_merge($entries, $xml);

    $textArray = [];
//Filling empty array with feed entry titles and summaries, removing html tags
    foreach ($entries as $entry) {
        $textArray[] = strip_tags($entry->title . $entry->summary);
    }
//making array into string before passing to word count function
    $textArray = implode(',', $textArray);
    $words = str_word_count($textArray, 1);
//Top 50 Common English Words
    $commonWords = ['the', 'be', 'to', 'of', 'and', 'a', 'in', 'that', 'have',
        'I', 'it', 'for', 'not', 'on', 'with', 'he', 'as', 'you', 'do', 'at',
        'this', 'but', 'his', 'by', 'from', 'they', 'we', 'say', 'her', 'she',
        'or', 'an', 'will', 'my', 'one', 'all', 'would', 'there', 'their', 'what',
        'so', 'up', 'out', 'if', 'about', 'who', 'get', 'which', 'go', 'me'];
//Filter top 50 common English words out
    $words = array_diff($words, $commonWords);
//Scrap HTML - google it for scraping table from WIKI page
    $appearCount = array_count_values($words);
//Sorting array by value
    arsort($appearCount);
    ?>

<div class="d-flex flex-column align-items-center border">  

<?php if (auth()->check()): ?>
    <header class="d-flex flex-column align-items-center bg-primary rounded-bottom text-white text-uppercase">
    <!-- Showing authorised user -->
    <div class="p-2">Hello, <?php echo auth()->user()->name() ?>! Welcome to <?php echo config('app.name'); ?>.</div>
    <form action="/auth/logout" method="post">
        <button class='btn btn-info' type="submit">Logout</button>
    </form>
        <!-- Displaying top 10 most frequently used words in the whole feed view excluding 50 common English words-->
        <h3 class="white-text">Top 10 most frequently words used in the feed</h3>
        <p class="">
            <?php
            echo "| ";
            for ($i = 0; $i < 10; $i++) {
                echo "`".array_keys($appearCount)[$i]."`" . " : " . $appearCount[array_keys($appearCount)[$i]] . " | ";
            }
            ?>
        </p>
    </header>
    <ul>
        <?php
        //Print all the entries
        foreach ($entries as $entry) {
            if (isset($entry)):
                ?>
                <li class="feed border border-primary rounded-lg bg-light">
                    <a href="<?= $entry->link['href'] ?>"><?= $entry->title ?></a>
                    (<?= parse_url($entry->link['href'])['host'] ?>)
                    <p><?= strftime('%m/%d/%Y %I:%M %p', strtotime($entry->updated)) ?></p>
                    <p><?= $entry->summary ?></p>
                </li>
            <?php
            endif;
        } ?>
    </ul>
<?php else: ?>
    <h3 class="text-uppercase mg-top-sm"><?php echo config('app.name'); ?> greets you</h3>
    <div class="p-2">
        <a href="/auth/login" class='btn btn-success mx-1 my-2'>Sign In</a>
    </div>
    <div class="p-2">
    <a href="/register" class='btn btn-warning mx-1 my-2'>Register</a>
    </div>
<?php endif; ?>
</div>
<?php view('layouts/footer'); ?>
