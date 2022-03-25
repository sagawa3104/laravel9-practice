import ActionList from './ActionList';
import CategoryList from "./CategoryList";
import DetailArea from './DetailArea';
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
                <DetailArea />
                }
            </div>
            <div className="right-block">
                <ActionList {...props} />
            </div>
        </section>
    )
}

export default ActionArea;
