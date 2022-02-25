import { BrowserRouter, Route, Routes } from "react-router-dom";
import ReactDOM from 'react-dom';
import SearchInspection from "./SearchInspection/SearchInspection";
import InspectProduct from "./InspectProduct/InspectProduct";

function AppRoutes() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/react/search" element={<SearchInspection />} />
                <Route path="/react/inspect/:inspectId" element={<InspectProduct />} />
            </Routes>
        </BrowserRouter>
    );
}

if (document.getElementById('app')) {
    ReactDOM.render(<AppRoutes />, document.getElementById('app'));
}
