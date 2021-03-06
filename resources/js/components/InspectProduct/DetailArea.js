import DetailRow from "./DetailRow";

const DetailArea = ({selectedCell, mappingDetails, selectedUnit}) => {
    const displayDetails = mappingDetails.filter(detail => detail.unitId === selectedUnit.id && detail.xPoint === selectedCell.xPoint && detail.yPoint === selectedCell.yPoint);
    const rows = displayDetails.map((detail, index) => <DetailRow key={index} detail={detail} />);
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
                        {rows}
                    </tbody>
                    <tfoot className="list-table__foot">
                    </tfoot>
                </table>
            </div>
        </section>
    )
}

export default DetailArea;
