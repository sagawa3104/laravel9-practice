const ActionList = (props) => {

    const handleClick = () => {
        if(!Object.keys(props.selectedCell).length) return;
        props.openModal('add');
    }

    return(
        <ul className="vertical-list">
            <li className="vertical-list__item">
                <ul className="vertical-list">
                    <li className="vertical-list__item">
                        <div className="vertical-list__item__card button">完了</div>
                    </li>
                </ul>
            </li>
            <li className="vertical-list__item">操作
                <ul className="vertical-list">
                    <li className="vertical-list__item">
                        <div className="vertical-list__item__card button">検査メモ</div>
                    </li>
                    <li className="vertical-list__item">
                        <button className="vertical-list__item__card button" onClick={handleClick}>NG登録</button>
                    </li>
                </ul>
            </li>
        </ul>
    )
}

export default ActionList;
