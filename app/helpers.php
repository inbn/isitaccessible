<?php

function extractGitHubRepoFromUrl($url)
{
    preg_match('/^((?:git\+)?https|git)(:\/\/|@)([^\/:]+)[\/:]([^\/:]+)\/(.+).git$/', $url, $matches);
    return $matches[4] . '/' . $matches[5];
}
