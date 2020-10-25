<?php

function extractGitHubRepoFromUrl($url)
{
    preg_match('/^.+?(?=github\.com)([^\/:]+)\/(.+).git?$/', $url, $matches);
    return $matches[2];
}
