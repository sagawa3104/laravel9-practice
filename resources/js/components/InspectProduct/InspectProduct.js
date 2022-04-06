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

    const [inspectionDetails, setInspectionDetails] = useState();
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('http://localhost/api/recorded-inspections/' + inspection.id + '/details');
            setInspectionDetails(res.data);
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

    const [mappingDetails, setMappingDetails] = useState([]);
    useEffect(() => {
        const fetchData = () => {
            const mappedMappingDetails = inspectionDetails.filter((inspectionDetail)=> inspectionDetail.type === 'MAPPING')
            .map((inspectionDetail)=> {
                return {
                    inspectionDetailId:inspectionDetail.id,
                    unitId: inspectionDetail.recorded_inspection_detail_mapping.unit_id,
                    xPoint: inspectionDetail.recorded_inspection_detail_mapping.x_point,
                    yPoint: inspectionDetail.recorded_inspection_detail_mapping.y_point,
                    item: inspectionDetail.recorded_inspection_detail_mapping.item
                }
            });
            setMappingDetails(mappedMappingDetails);
        }

        if(inspectionDetails) fetchData();
    }, [inspectionDetails]);

    const [checkingDetails, setCheckingDetails] = useState([]);
    useEffect(() => {
        const fetchData = () => {
            const mappedCheckingDetails = inspectionDetails.filter((inspectionDetail)=> inspectionDetail.type === 'CHECKING')
            .map((inspectionDetail)=> {
                return {
                    inspectionDetailId:inspectionDetail.id,
                    type: inspectionDetail.recorded_inspection_detail_checking.type,
                    item: inspectionDetail.recorded_inspection_detail_checking.item,
                    specification: inspectionDetail.recorded_inspection_detail_checking.specification,
                    specialSpecification: inspectionDetail.recorded_inspection_detail_checking.special_specification,
                }
            });
            setCheckingDetails(mappedCheckingDetails);
        }

        if(inspectionDetails) fetchData();
    }, [inspectionDetails]);

    const addDetail = (data) => {
        axios.post('http://localhost/api/recorded-inspections/' + inspection.id + '/details', {
            type:'MAPPING',
            unitId: selectedUnit.id,
            itemId: data.item,
            xPoint:selectedCell.xPoint,
            yPoint:selectedCell.yPoint
        }).then(res=> {
            setInspectionDetails([...inspectionDetails, res.data]);
            setSelectedCell({});
        });
    }

    const checkItem = (params) => {
        console.log(params);
        axios.post('http://localhost/api/recorded-inspections/' + inspection.id + '/details', {
            type:'CHECKING',
            ...params,
        }).then(res=> {
            setInspectionDetails([...inspectionDetails, res.data]);
        });
    }

    const uncheckItem = (params) => {
        const targetDetail = inspectionDetails.filter((detail)=> detail.type === 'CHECKING')
        .find((detail) => {
            if(params.itemType === 'ITEM') return detail.recorded_inspection_detail_checking.item_id == params.itemId;
            if(params.itemType === 'SPECIFICATION') return detail.recorded_inspection_detail_checking.specification_id == params.specificationId;
        });
        axios.delete('http://localhost/api/recorded-inspections/' + inspection.id + '/details/' + targetDetail.id)
        .then(res=> {
            const removedDetails = inspectionDetails.filter((detail) => detail.id !== targetDetail.id);
            setInspectionDetails([...removedDetails]);
        });
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
        mappingDetails,
        checkingDetails,
        addDetail,
        checkItem,
        uncheckItem,
    };

    const modal = modalName? <AddDetailModal {...props}/>:null;
    return(
        <div className="react-wrapper">
            <InfoArea inspectId={params.inspectId} />
            <div className="flex-container">
                <ActionArea {...props} />
                <DetailArea {...props} />
            </div>
            {modal}
        </div>
    )
}

export default InspectProduct;
