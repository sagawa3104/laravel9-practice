const CheckingDetailRow = ({checkingDetails, item, type, checkItem, uncheckItem}) => {
    const isChecked = checkingDetails.findIndex((detail) => {
        if(detail.type === 'ITEM') return detail.item.id === item.id
        if(detail.type === 'SPECIFICATION') return detail.specification.id === item.id
        if(detail.type === 'SPECIALSPECIFICATION') return detail.specialSpecification.id === item.id
    }) !== -1;
    const handleChange = (e) => {
        let params = {};
        switch (type){
            case 'ITEM':
                params.itemType = type;
                params.itemId = e.target.value;
                break;
            case 'SPECIFICATION':
                params.itemType = type;
                params.specificationId = e.target.value;
                break;
            case 'SPECIALSPECIFICAITON':
                params.itemType = type;
                params.specialSpecificationId = e.target.value;
                break;
        }
        if(e.target.checked){
            checkItem(params);
        }else{
            uncheckItem(params);
        }
    };
    return(
        <tr>
            <td>{item.code}</td>
            <td>{item.name}</td>
            <td>
                <div className="attach-list__item">
                    <input className="toggle-input" type="checkbox" id={item.code} name={item.code} value={item.id} onChange={(e) => handleChange(e)} checked={isChecked} />
                    <label className="toggle-label" htmlFor={item.code}></label>
                </div>
            </td>
            <td>
                <button className="button">詳細</button>
            </td>
        </tr>
    )
}

export default CheckingDetailRow;
