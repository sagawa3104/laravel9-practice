import UnitCard from "./UnitCard";

const UnitList = (props) => {
    const units = props.units;
    const unitCards = units? units.map((unit) => (<UnitCard key={unit.id} unit={unit} selectUnit={props.selectUnit} selectedUnit={props.selectedUnit}/>)):null;
    return(
        <ul className="vertical-list">
            <li className="vertical-list__item">部位
                <ul className="vertical-list">
                    {unitCards}
                </ul>
            </li>
        </ul>
    )
}

export default UnitList;
