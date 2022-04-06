const CheckingDetailRow = ({checkingDetails, item, checkItem, uncheckItem}) => {
    const isChecked = checkingDetails.findIndex(detail => detail.item.id === item.id) !== -1;
    const handleChange = (e) => {
        console.log(e.target.checked);
        if(e.target.checked){
            checkItem(e.target.value);
        }else{
            uncheckItem(e.target.value);
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
