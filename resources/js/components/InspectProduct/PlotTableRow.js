import PlotTableCell from "./PlotTableCell";

const PlotTableRow = (props) => {
    const details = props.details;
    const rowNum = props.rowNum;
    const cellCount = 20;
    const cells = [...Array(cellCount)].map((value, index) => {
        const filteredDetails = details? details.filter((detail)=> {
            return detail.recorded_mapping_item.x_point == index + 1 && detail.recorded_mapping_item.y_point == rowNum;
        }):null;
        return <PlotTableCell key={index} rowNum={rowNum} colNum={index + 1} details={filteredDetails} selectCell={props.selectCell} selectedCell={props.selectedCell}/>}
        );
    return(
        <div className="image-box__plot-table__row">
            {cells}
        </div>
    )
}

export default PlotTableRow;
