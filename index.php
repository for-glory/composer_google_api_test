<?php
    require_once('./vendor/autoload.php');

    use Google\Client;
    use Google\Service\SearchConsole;
    use Google\Service\SearchConsole\SearchAnalyticsQueryRequest;

    $site = "https://www.mockquestions.com";

    $KEY_FILE_LOCATION = __DIR__ . '/eng-node-366522-e546e3fdf45b.json';
    // putenv("GOOGLE_APPLICATION_CREDENTIALS=$KEY_FILE_LOCATION");
    $client = new Client();
    // I don't think this is really necessary as the environment variable is already set.
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setApplicationName("google-search-console");
    $client->setScopes(["https://www.googleapis.com/auth/webmasters.readonly"]);
    $searchConsole = new SearchConsole($client);

    $queryRequest = new SearchAnalyticsQueryRequest();
    $queryRequest->setStartDate("2022-04-01");
    $queryRequest->setEndDate("2022-04-04");
    $queryRequest->setDimensions(["QUERY","PAGE"]);
    
    $dimensionFilter = new Google\Service\Webmasters\ApiDimensionFilter();
    $dimensionFilter->setDimension('query');
    $dimensionFilter->setOperator('contains');
    $dimensionFilter->setExpression('Apple Interview Questions');
    $dimensionfilterGroup = new Google\Service\Webmasters\ApiDimensionFilterGroup();
    $dimensionfilterGroup->setFilters(array($dimensionFilter));
    $queryRequest->setDimensionFilterGroups(array($dimensionfilterGroup));

    $response = $searchConsole->searchanalytics->query($site, $queryRequest);
    echo $response;
