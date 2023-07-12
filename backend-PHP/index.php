<?php
    class DaData {
        // Api settings
        private string $API_KEY = '4b8a7b9d1a53b30e6faf1b9ebd2330e1758e5530';
        private string $API_HOST = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById';
        // Test data will be stored here
        private string $TEST_INN;
        private string $TEST_BIK;
        // Results will be stored here
        private string $INN_COMPANY = '';
        private string $BIK_COMPANY = '';

        // Set default values for new instance
        function __construct(string $inn, string $bik) {
            $this->TEST_INN = $inn;
            $this->TEST_BIK = $bik;
        }

        // Fetch remote data
        function curl_get_contents(string $url, string $data) {
            $post_data = array('query' => $data);
            // Initiate the curl session
            $ch = curl_init($url);
            // Set the URL
            // curl_setopt($ch, CURLOPT_URL, $url);
            // Removes the headers from the output
            curl_setopt($ch, CURLOPT_HEADER, 0);
            // Return the output instead of displaying it directly
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // Set Authorization
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "Authorization: Token " . $this->API_KEY
            ));
            // Set request method to POST
            curl_setopt($ch, CURLOPT_POST, 1);
            // Set POST data
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            // Follow redirects just in case
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

            // Execute the curl session
            $output = curl_exec($ch);
            // Decoding result
            $decoded = json_decode($output, true);
            // Grep first record from result
            $first_el = array_shift($decoded['suggestions']);
            // Close the curl session
            curl_close($ch);
            // Return the output as a variable
            return $first_el['value'];
        }

        // Get company name by INN
        function findByINN($inn) {
            $url = $this->API_HOST . '/party';
            $this->INN_COMPANY = $this->curl_get_contents($url, $this->TEST_INN);
        }

        // Get company name by BIK
        function findByBIK($bik) {
            $url = $this->API_HOST . '/bank';
            $this->BIK_COMPANY = $this->curl_get_contents($url, $this->TEST_BIK);
        }

        // Print results to console
        function print_result() {
            echo "INN# $this->TEST_INN belong to $this->INN_COMPANY\n";
            echo "BIK# $this->TEST_BIK belong to $this->BIK_COMPANY\n";
        }
    }

    // Test data
    const INN = '7707083893';
    const BIK = '044525225';

    // Fetching results
    $fetcher = new DaData(INN, BIK);
    $fetcher->findByINN(INN);
    $fetcher->findByBIK(BIK);

    // Printing results
    $fetcher->print_result();
?>
