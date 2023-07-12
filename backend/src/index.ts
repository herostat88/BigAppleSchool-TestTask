import DaData from './daData';

// Test data
const INN = '7707083893'
const BIK = '044525225'

// Create new instance of DaData
const apiFetcher = new DaData();

(async () => {
    const innCompany = await apiFetcher.findByINN(INN);
    const bikCompany = await apiFetcher.findByBIK(BIK);
    console.log('INN# ' + INN + ' belong to `' + innCompany + '`');
    console.log('BIK# '+ BIK + ' belong to `' + bikCompany + '`');
})();
