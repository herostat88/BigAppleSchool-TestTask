import axios from 'axios';

export default class DaData {
    private readonly API_KEY = '4b8a7b9d1a53b30e6faf1b9ebd2330e1758e5530';
    private readonly API_HOST = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById';

    public reqHeaders; // Define request headers

    // Create request headers on start
    constructor() {
        this.reqHeaders = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Token ' + this.API_KEY
        }
    }

    // Get company name by INN
    async findByINN(inn: string): Promise<string> {
        // POST request to API server
        return await axios.post(this.API_HOST + '/party', { query: inn }, { headers: this.reqHeaders })
            .then((response) => {
                // Return first match value
                return response?.data?.suggestions[0]?.value as string;
            })
            .catch(() => {
                throw new Error('Unable to fetch data by INN');
            });
    }

    // Get company name by BIK
    async findByBIK(bik: string): Promise<string> {
        // POST request to API server
        return await axios.post(this.API_HOST + '/bank', { query: bik }, { headers: this.reqHeaders })
            .then((response) => {
                // Return first match value
                return response?.data?.suggestions[0]?.value as string;
            })
            .catch(() => {
                throw new Error('Unable to fetch data by BIK');
            });
    }
}
    
