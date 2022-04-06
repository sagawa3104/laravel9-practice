import CheckingDetailRow from "./CheckingDetailRow";

const CheckingDetailArea = ({checkingDetails, selectedCategory, checkItem, uncheckItem}) => {
    const checkingItems = selectedCategory.items;
    const itemRows = checkingItems.map((item, key) => <CheckingDetailRow {...{key, item, checkingDetails, checkItem, uncheckItem}} type="ITEM" />)
    return(
        <section className="detail-area">
            <div className="result-details-box">
                <table className="list-table">
                    <thead className="list-table__head">
                        <tr>
                            <th>カラム1</th>
                            <th>カラム2</th>
                            <th>OK/NG</th>
                            <th>カラム3</th>
                        </tr>
                    </thead>
                    <tbody className="list-table__body">
                    {itemRows}
                    </tbody>
                    <tfoot className="list-table__foot">
                    </tfoot>
                </table>
            </div>
        </section>
    )
}

export default CheckingDetailArea;
