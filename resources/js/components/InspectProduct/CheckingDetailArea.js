import CheckingDetailRow from "./CheckingDetailRow";

const CheckingDetailArea = ({inspection, checkingDetails, selectedCategory, checkItem, uncheckItem}) => {
    const checkingItems = selectedCategory.items;
    const checkingSpecifications = selectedCategory.specifications
    // カテゴリに設定され且つ品目に設定された仕様を抽出する
    .filter((cSpecification) => inspection.recorded_product.product.specifications
        .find((pSpecification)=> cSpecification.id === pSpecification.id));
    const itemRows = checkingItems.map((item, key) => <CheckingDetailRow {...{key, item, checkingDetails, checkItem, uncheckItem}} type="ITEM" />)
    const specificationRows = checkingSpecifications.map((item, key) => <CheckingDetailRow {...{key, item, checkingDetails, checkItem, uncheckItem}} type="SPECIFICATION" />)
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
                    {specificationRows}
                    </tbody>
                    <tfoot className="list-table__foot">
                    </tfoot>
                </table>
            </div>
        </section>
    )
}

export default CheckingDetailArea;
