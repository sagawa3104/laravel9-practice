const DetailRow = ({detail}) => {
    return(
        <tr>
            <td>{detail.item.code}</td>
            <td>{detail.item.name}</td>
            <td>
                <button className="button">詳細</button>
            </td>
        </tr>
    )
}

export default DetailRow;
