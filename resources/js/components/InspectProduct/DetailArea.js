const DetailArea = () => {

    return(
        <section className="detail-area">
            <div className="result-details-box">
                <table className="list-table">
                    <thead className="list-table__head">
                        <tr>
                            <th>カラム1</th>
                            <th>カラム2</th>
                            <th>カラム3</th>
                        </tr>
                    </thead>
                    <tbody className="list-table__body">
                        <tr>
                            <td>value1</td>
                            <td>value2</td>
                            <td>value3</td>
                        </tr>
                        <tr>
                            <td>value1</td>
                            <td>value2</td>
                            <td>value3</td>
                        </tr>
                        <tr>
                            <td>value1</td>
                            <td>value2</td>
                            <td>value3</td>
                        </tr>
                    </tbody>
                    <tfoot className="list-table__foot">
                    </tfoot>
                </table>
            </div>
        </section>
    )
}

export default DetailArea;
