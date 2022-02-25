import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import DetailArea from './DetailArea';
import ActionArea from './ActionArea';
import InfoArea from './InfoArea';

const InspectProduct = () => {
    const params = useParams()

    const [inspection, setInspection] = useState();
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('http://localhost/api/inspections/' + params.inspectId);
            setInspection(res.data);
        };
        fetchData();
    }, []);

    const [selectedCell, setSelectedCell] = useState({});
    const selectCell = (xPoint, yPoint) => {
        console.log('clicked on X:'+ xPoint + '  Y:'+ yPoint);
        setSelectedCell({xPoint:xPoint, yPoint:yPoint});
    }
    return(
        <div className="react-wrapper">
            <InfoArea inspectId={params.inspectId} />
            <ActionArea inspection={inspection} selectCell={selectCell} selectedCell={selectedCell} />
            <DetailArea/>
        </div>
    )
}

export default InspectProduct;
