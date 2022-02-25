const PlotTableCell = (props) => {
    const details = props.details? props.details:[];

    const handleClick = ()=>{
        props.selectCell(props.colNum, props.rowNum)
    }
    const cellColor = details.length >= 3? ' image-box__plot-table__row__cell--red': details.length >= 2? ' image-box__plot-table__row__cell--yellow' : details.length >= 1? ' image-box__plot-table__row__cell--blue':'';
    const cellSelected=props.selectedCell.xPoint == props.colNum && props.selectedCell.yPoint == props.rowNum? ' image-box__plot-table__row__cell--selected':'';
    return(
        <div className={'image-box__plot-table__row__cell' + cellColor +cellSelected} onClick={handleClick}>{details.length>0? details.length:null} &nbsp;</div>
    )
}

export default PlotTableCell;
