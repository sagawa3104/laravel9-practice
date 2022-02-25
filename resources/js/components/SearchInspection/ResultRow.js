import { Link } from "react-router-dom";

const ResultRow = (props) => {
    return(
        <tr>
            <td>{props.result.recorded_product.recorded_number}</td>
            <td>{props.result.process.name}</td>
            <td>{props.result.recorded_product.product.name}</td>
            <td>{props.result.form}</td>
            <td>
                <Link to={'/react/inspect/'+ props.result.id} className="button">検査画面へ</Link>
            </td>
        </tr>
    )
}

export default ResultRow;
