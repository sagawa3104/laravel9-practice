const ActionList = (props) => {

    const handleClick = () => {
        console.log("NG登録 clicked");
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
                        <div className="vertical-list__item__card button" onClick={handleClick}>NG登録</div>
                    </li>
                </ul>
            </li>
        </ul>
    )
}

export default ActionList;
