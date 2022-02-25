import { Link } from "react-router-dom";

const InfoArea = (props) => {

    return(
        <section className="info-area">
            <Link to={'/react/search'} className='button button--cancel'>戻る</Link>
            <p>情報エリア:検査ID{props.inspectId}</p>
        </section>
    )
}

export default InfoArea;
