import { useState } from 'react';

const AddDetailModal = (props) => {
    const [item, setItem] = useState();
    const closeModal = () => {
        props.closeModal();
    }
    const handleClick = () => {
        const data = {
            item: item,
        }
        props.addDetail(data);
        props.closeModal();
    }
    const itemOptions = props.selectedCategory.items.map(item => (<option key={item.id} value={item.id}>{item.name}</option>));
    return(
        <div className="react-modal">
            <a href="#!" className="react-modal__overlay" onClick={closeModal}></a>
            <div className="react-modal__window">
                <a href="#!" className="react-modal__window__close-mark" onClick={closeModal}>X</a>
                <div className="form-box">
                    <div className="form-box__header">
                        <h1></h1>
                    </div>
                    <div className="form-box__content">
                        <p>検査明細を登録する</p>
                        <div className="form__group">
                            <label className="form-label">項目</label>
                            <select className="form-input form-input--select" name="item"
                            value={item} onChange={(e) => setItem(e.target.value)}>
                                <option key={0} value="">----</option>
                                {itemOptions}
                            </select>
                        </div>
                    </div>
                    <div className="form-box__footer">
                            <button className="button" onClick={handleClick}>登録</button>
                            <button className="button button--cancel" onClick={closeModal}>キャンセル</button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default AddDetailModal;
