import { useEffect, useState } from "react";

const SearchArea = (props) => {
    const [recordedProductNumber, setRecordedProductNumber] = useState('test');
    const [process, setProcess] = useState('');

    const processes = props.processes;
    const processOptions = processes.map(process => (<option key={process.id} value={process.id}>{process.name}</option>));

    const handleSubmit = (e) => {
        e.preventDefault();
        props.fetchData(recordedProductNumber, process);
    }

    return(
        <section className="search-area">
            <div className="search-box">
                <form className="form form--flex" onSubmit={handleSubmit}>
                    <div className="form__group">
                        <label className="form-label">製番</label>
                        <input type="text" className="form-input" name="recorded_product_number"
                        value={recordedProductNumber} onChange={(e) => setRecordedProductNumber(e.target.value)} />
                    </div>
                    <div className="form__group">
                        <label className="form-label">工程</label>
                        <select className="form-input form-input--select" name="process"
                        value={process} onChange={(e) => setProcess(e.target.value)}>
                            <option key={0} value="">----</option>
                            {processOptions}
                        </select>
                    </div>
                    <div className="form__group">
                        <button className="button">検索</button>
                    </div>
                </form>
            </div>
        </section>
    )
}

export default SearchArea;
