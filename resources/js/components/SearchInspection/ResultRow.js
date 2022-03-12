import { Link } from "react-router-dom";

const ResultRow = (props) => {
    return(
        <tr>
            <td>{props.result.recorded_product.code}</td>
            <td>{props.result.phase.name}</td>
            <td>{props.result.recorded_product.product.name}</td>
            <td>
                <Link to={'/react/inspect/'+ props.result.id} className="button">検査画面へ</Link>
            </td>
        </tr>
    )
}

export default ResultRow;
