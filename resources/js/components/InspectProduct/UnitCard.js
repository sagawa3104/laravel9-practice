const UnitCard = (props) => {
    const handleClick = () => {
        props.selectUnit(props.unit);
    };
    const isSelected = props.selectedUnit && props.selectedUnit.id == props.unit.id;
    return(
        <li className="vertical-list__item">
            <div className="vertical-list__item__card" onClick={handleClick} data-selected={isSelected} >{props.unit.name}</div>
        </li>
    )
}

export default UnitCard;
