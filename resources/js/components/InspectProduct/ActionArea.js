import PlotTableRow from "./PlotTableRow";

const ActionArea = (props) => {
    const inspection = props.inspection;
    const details = inspection? inspection.inspection_details:null;
    const rowRount = 20;
    const rows = [...Array(rowRount)].map((value, index) => (<PlotTableRow key={index} rowNum={index + 1} details={details} selectCell={props.selectCell} selectedCell={props.selectedCell} />) );
    return(
        <section className="image-area">
            <div className="left-block">
                <ul className="vertical-list">
                    <li className="vertical-list__item">Mapping
                        <ul className="vertical-list">
                            <li className="vertical-list__item">
                                <div className="vertical-list__item__card">工程1</div>
                            </li>
                            <li className="vertical-list__item">
                                <div className="vertical-list__item__card">工程3</div>
                            </li>
                        </ul>
                    </li>
                    <li className="vertical-list__item">checklist
                        <ul className="vertical-list">
                            <li className="vertical-list__item">
                                <div className="vertical-list__item__card">工程2</div>
                            </li>
                        </ul>
                    </li>
                    <li className="vertical-list__item">部位
                        <ul className="vertical-list">
                            <li className="vertical-list__item">
                                <div className="vertical-list__item__card">部位1</div>
                            </li>
                            <li className="vertical-list__item">
                                <div className="vertical-list__item__card">部位2</div>
                            </li>
                            <li className="vertical-list__item">
                                <div className="vertical-list__item__card">部位3</div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div className="image-box">
                <img className="image-box__image" src="http://localhost/img/200x150.png" />
                <div className="image-box__plot-table">
                    {rows}
                </div>
            </div>
            <div className="right-block">
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
                                <div className="vertical-list__item__card button">NG登録</div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
    )
}

export default ActionArea;
