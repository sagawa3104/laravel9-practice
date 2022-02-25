import React, { useEffect, useState } from 'react';
import ResultsArea from './ResultsArea';
import SearchArea from './SearchArea';

const SearchInspection = () => {

    const [processes, setProcesses] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('http://localhost/api/processes');
            setProcesses(res.data);
        };
        fetchData();
    }, []);

    const [results, setResults] = useState();
    const fetchData = async (recordedProductNumber,process) => {
        const res = await axios.get('http://localhost/api/inspections', {
            params:{
                'recorded_number' : recordedProductNumber,
                'process' : process,
            }
        });
        setResults(res.data);
    }

    return(
        <div className="react-wrapper">
            <SearchArea processes={processes} fetchData={fetchData} />
            <ResultsArea results={results} />
        </div>
    )
}

export default SearchInspection;
