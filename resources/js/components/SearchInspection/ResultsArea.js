import { useEffect, useState } from "react";
import ResultRow from "./ResultRow";

const ResultsArea = (props) => {
    const results = props.results;
    const [rows, setRows] = useState();
    useEffect( ()=>{
        const resultRows = results? results.data.map((result) => <ResultRow key={result.id} result={result}></ResultRow>) : null;
        setRows(resultRows);
    }, [results]);
    return(
        <section className="result-area">
            <div className="results-box">
                <table className="list-table">
                    <thead className="list-table__head">
                        <tr>
                            <th>製番</th>
                            <th>工程</th>
                            <th>品目</th>
                            <th>方式</th>
                            <th>検査</th>
                        </tr>
                    </thead>
                    <tbody className="list-table__body">
                        {rows}
                    </tbody>
                    <tfoot  className="list-table__foot"></tfoot>
                </table>
            </div>
        </section>
    )
}

export default ResultsArea;
