import PlotTableCell from "./PlotTableCell";

const PlotTableRow = (props) => {
    const details = props.details;
    const rowNum = props.rowNum;
    const cellCount = props.selectedUnit.x_length;
    const cells = [...Array(cellCount)].map((value, index) => {
        const filteredDetails = details? details.filter((detail)=> {
            return detail.xPoint == index + 1 && detail.yPoint == rowNum;
        }):null;
        return <PlotTableCell key={index} rowNum={rowNum} colNum={index + 1} details={filteredDetails} selectCell={props.selectCell} selectedCell={props.selectedCell}/>}
        );
    return(
        <div className="plot-box__grid__row">
            {cells}
        </div>
    )
}

export default PlotTableRow;
