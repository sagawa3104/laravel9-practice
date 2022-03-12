import React, { useEffect, useState } from 'react';
import ResultsArea from './ResultsArea';
import SearchArea from './SearchArea';

const SearchInspection = () => {

    const [phases, setPhases] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('http://localhost/api/phases');
            setPhases(res.data);
        };
        fetchData();
    }, []);

    const [results, setResults] = useState();
    const fetchData = async (recordedProductCode,phase) => {
        const res = await axios.get('http://localhost/api/recorded-inspections', {
            params:{
                'code' : recordedProductCode,
                'phase' : phase,
            }
        });
        setResults(res.data);
    }

    return(
        <div className="react-wrapper">
            <SearchArea phases={phases} fetchData={fetchData} />
            <ResultsArea results={results} />
        </div>
    )
}

export default SearchInspection;
