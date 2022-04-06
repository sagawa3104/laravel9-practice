import PlotTableRow from "./PlotTableRow";

const PlotBox = (props) => {
    const details = props.mappingDetails.filter(detail => detail.unitId === props.selectedUnit.id);
    const rowCount = props.selectedUnit.y_length;
    const childProps = {...props};
    childProps.details = [...details];
    const rows = [...Array(rowCount)].map((value, index) => (<PlotTableRow key={index} rowNum={index + 1} {...childProps}/>) );

    return(
        <div className="plot-box">
            <img className="plot-box__image" src="http://localhost/img/200x150.png" />
            <div className="plot-box__grid">
                {rows}
            </div>
        </div>
    )
}

export default PlotBox;
