import React, { useEffect, useState } from "react";
import Counter from "./Counter";

export default function Dashboard()
{
    const [customerCounter, setCustomerCounter] = useState(0);
    const [companyCounter, setCompanyCounter] = useState(0);
    const [jobCounter, setJobCounter] = useState(0);

    useEffect(() => {
        fetch("/api/counters")
        .then(response => response.json())
        .then(data => {
            setCustomerCounter(data.customers);
            setCompanyCounter(data.companies);
            setJobCounter(data.jobs);
        })
    }, [])


    return (
        <div className="container">
            <h1>Dashboard</h1>
            <div className="row">
                <Counter label={"Clients"} value={ customerCounter }/>
                <Counter label={"Entreprises"} value={ companyCounter }/>
                <Counter label={"Postes"} value={ jobCounter }/>
            </div>
        </div>
    );
}
