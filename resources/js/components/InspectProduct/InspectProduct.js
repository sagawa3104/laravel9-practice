import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import DetailArea from './DetailArea';
import ActionArea from './ActionArea';
import InfoArea from './InfoArea';
import axios from 'axios';
import AddDetailModal from './AddDetailModal';

const InspectProduct = () => {
    const params = useParams()

    const [modalName, setModalName] = useState(null);
    const openModal = (modalName) => {
        setModalName(modalName);
    }
    const closeModal = () => {
        setModalName(null);
    }

    const [inspection, setInspection] = useState();
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('http://localhost/api/recorded-inspections/' + params.recordedInspectionId);
            setInspection(res.data);
        };
        fetchData();
    }, []);

    const [categories, setCategories] = useState();
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('http://localhost/api/recorded-inspections/' + inspection.id + '/categories');
            setCategories(res.data);
        };

        if(inspection) fetchData();
    }, [inspection]);

    const [units, setUnits] = useState();
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('http://localhost/api/recorded-inspections/' + inspection.id + '/units');
            setUnits(res.data);
        };

        if(inspection) fetchData();
    }, [inspection]);

    const [selectedCategory, setSelectedCategory] = useState({});
    useEffect(() => {
        // 最初のマッピングカテゴリを初期選択にする。
        if(categories) selectCategory(categories.filter(category => category.form == 'MAPPING')[0] );
    }, [categories]);

    const selectCategory = (category) => {
        setSelectedCategory(category);
    }

    const [selectedUnit, setSelectedUnit] = useState({});
    useEffect(() => {
        // 最初の部位を初期選択にする。
        if(units) selectUnit(units[0] );
    }, [units]);

    const selectUnit = (unit) => {
        setSelectedCell({});
        setSelectedUnit(unit);
    }

    const [selectedCell, setSelectedCell] = useState({});
    const selectCell = (xPoint, yPoint) => {
        setSelectedCell({xPoint:xPoint, yPoint:yPoint});
    }

    const [details, setDetails] = useState([]);
    const addDetail = (data) => {
        console.log(data);
        const detail = {
            unitId: selectedUnit.id,
            itemId: data.item,
            xPoint:selectedCell.xPoint,
            yPoint:selectedCell.yPoint
        };
        setDetails([...details, detail]);
        setSelectedCell({});
    }

    const props = {
        inspection,
        categories,
        selectedCategory,
        selectCategory,
        units,
        selectedUnit,
        selectUnit,
        selectedCell,
        selectCell,
        openModal,
        closeModal,
        details,
        addDetail,
    };

    const modal = modalName? <AddDetailModal {...props}/>:null;
    return(
        <div className="react-wrapper">
            <InfoArea inspectId={params.inspectId} />
            <div className="flex-container">
                <ActionArea {...props} />
                <DetailArea/>
            </div>
            {modal}
        </div>
    )
}

export default InspectProduct;
