import { useEffect, useState } from "react";

const SearchArea = (props) => {
    const [recordedProductCode, setRecordedProductCode] = useState('');
    const [phase, setPhase] = useState('');

    const phases = props.phases;
    const phaseOptions = phases.map(phase => (<option key={phase.id} value={phase.id}>{phase.name}</option>));

    const handleSubmit = (e) => {
        e.preventDefault();
        props.fetchData(recordedProductCode, phase);
    }

    return(
        <section className="search-area">
            <div className="search-box">
                <form className="form form--flex" onSubmit={handleSubmit}>
                    <div className="form__group">
                        <label className="form-label">製番</label>
                        <input type="text" className="form-input" name="recorded_product_code"
                        value={recordedProductCode} onChange={(e) => setRecordedProductCode(e.target.value)} />
                    </div>
                    <div className="form__group">
                        <label className="form-label">工程</label>
                        <select className="form-input form-input--select" name="phase"
                        value={phase} onChange={(e) => setPhase(e.target.value)}>
                            <option key={0} value="">----</option>
                            {phaseOptions}
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
