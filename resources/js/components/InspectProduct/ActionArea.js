import ActionList from './ActionList';
import CategoryList from "./CategoryList";
import CheckingDetailArea from './CheckingDetailArea';
import PlotBox from './PlotBox';
import UnitList from "./UnitList";

const ActionArea = (props) => {

    return(
        <section className="action-area">
            <div className="left-block">
                <CategoryList {...props} />
                <UnitList {...props} />
            </div>
            <div className='center-area'>
                {props.selectedCategory.form==='MAPPING'? <PlotBox {...props} />:
                props.selectedCategory.form==='CHECKLIST'? <CheckingDetailArea {...props} />:
                null
                }
            </div>
            <div className="right-block">
                <ActionList {...props} />
            </div>
        </section>
    )
}

export default ActionArea;
