const PlotTableCell = (props) => {
    const details = props.details? props.details:[];

    const handleClick = ()=>{
        props.selectCell(props.colNum, props.rowNum)
    }
    const cellColor = details.length >= 3? ' plot-box__grid__row__cell--red': details.length >= 2? ' plot-box__grid__row__cell--yellow' : details.length >= 1? ' plot-box__grid__row__cell--blue':'';
    const cellSelected=props.selectedCell.xPoint == props.colNum && props.selectedCell.yPoint == props.rowNum? ' plot-box__grid__row__cell--selected':'';
    return(
        <div className={'plot-box__grid__row__cell' + cellColor +cellSelected} onClick={handleClick}>{details.length>0? details.length:null} &nbsp;</div>
    )
}

export default PlotTableCell;
